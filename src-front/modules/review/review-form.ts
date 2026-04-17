type ReviewSubmitState = 'idle' | 'success' | 'error';

export class ReviewForm {
    public constructor(
        private readonly formSelector: string,
        private readonly statusSelector: string,
    ) {
    }

    public init(): void {
        document.addEventListener('DOMContentLoaded', () => {
            const formElement = document.querySelector<HTMLFormElement>(this.formSelector);

            if (formElement === null) {
                return;
            }

            formElement.addEventListener('submit', (event) => {
                event.preventDefault();

                void this.submit(formElement);
            });
        });
    }

    private async submit(formElement: HTMLFormElement): Promise<void> {
        const endpoint = formElement.dataset.endpoint;

        if (endpoint === undefined || endpoint === '') {
            this.setStatus(formElement, 'Form endpoint is not configured.', 'error');

            return;
        }

        const submitButton = formElement.querySelector<HTMLButtonElement>('button[type="submit"]');

        if (submitButton !== null) {
            submitButton.disabled = true;
        }

        this.setStatus(formElement, 'Sending review...', 'idle');

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                body: new FormData(formElement),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const responseBody = await this.parseJsonResponse(response);
            const message = typeof responseBody?.message === 'string' ? responseBody.message : null;

            if (!response.ok) {
                throw new Error(message ?? 'Review could not be sent.');
            }

            formElement.reset();
            this.setStatus(formElement, message ?? 'Review sent successfully.', 'success');
        } catch (error) {
            const fallbackMessage = 'Review could not be sent.';
            const message = error instanceof Error ? error.message : fallbackMessage;

            this.setStatus(formElement, message || fallbackMessage, 'error');
        } finally {
            if (submitButton !== null) {
                submitButton.disabled = false;
            }
        }
    }

    private async parseJsonResponse(response: Response): Promise<null | { message?: unknown }> {
        try {
            return await response.json() as { message?: unknown };
        } catch {
            return null;
        }
    }

    private setStatus(formElement: HTMLFormElement, message: string, state: ReviewSubmitState): void {
        const statusElement = formElement.querySelector<HTMLElement>(this.statusSelector);

        if (statusElement === null) {
            return;
        }

        statusElement.dataset.state = state;
        statusElement.textContent = message;
    }
}
