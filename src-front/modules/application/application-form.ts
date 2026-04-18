type SubmitState = 'idle' | 'success' | 'error';
type DynamicFieldType = 'text' | 'number' | 'textarea' | 'select' | 'checkbox';

type DynamicField = {
    name: string;
    label: string;
    type: DynamicFieldType;
    options?: string[];
    fullWidth?: boolean;
};

type DynamicFieldsConfig = Record<string, DynamicField[]>;

const PROJECT_TYPE_SELECTOR = '#projectType';
const DYNAMIC_FIELDS_SELECTOR = '[data-dynamic-fields]';

const TYPE_FIELDS_CONFIG: DynamicFieldsConfig = {
    'Media Wall': [
        {
            name: 'homeType',
            label: 'Home type',
            type: 'select',
            options: [
                'Detached',
                'TownHouse with garage/driveway',
                'Condo Townhouse (no driveway)',
                'Condo',
            ],
        },
        {
            name: 'fireplaceUnit',
            label: 'Fireplace unit',
            type: 'select',
            options: [
                'Need new electric fireplace - keeping',
                'Existing Electric fireplace - keeping',
                'Need new gas fireplace',
                'Existing gas fireplace - keeping',
                'Existing gas fireplace - change to electric',
                'Other',
            ],
        },
        {
            name: 'finishWanted',
            label: 'Finish wanted',
            type: 'select',
            options: [
                'Limeplaster / Microcement / Venetian plaster',
                'Limewash Paint finish',
                'Wood slates',
                'Ribbed panels',
                'Large MDF Panels',
                'Shiplap',
                'Concrete Panel',
                'Tile',
                'Stone',
                'Not sure',
            ],
            fullWidth: true,
        },
        {
            name: 'spaceSetup',
            label: 'Describe your space setup',
            type: 'textarea',
            fullWidth: true,
        },
        {
            name: 'howDidYourHearAboutUs',
            label: 'How did you hear about us?',
            type: 'textarea',
            fullWidth: true,
        },
    ],
    'Basement Renovation': [
        { name: 'square_feet', label: 'Approximate basement square footage', type: 'number' },
        {
            name: 'ceiling_height',
            label: 'Ceiling height',
            type: 'select',
            options: ['Under 7 ft', '7-8 ft', '8+ ft', 'Not sure'],
        },
        {
            name: 'unfinished_or_finished',
            label: 'Current basement condition',
            type: 'select',
            options: ['Unfinished', 'Partially finished', 'Finished - remodel needed'],
        },
        {
            name: 'rough_ins',
            label: 'Existing bathroom rough-ins?',
            type: 'select',
            options: ['Yes', 'No', 'Not sure'],
        },
        {
            name: 'kitchen_or_bar',
            label: 'Need kitchenette or wet bar?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'bedrooms',
            label: 'How many bedrooms do you want?',
            type: 'select',
            options: ['0', '1', '2', '3+'],
        },
        {
            name: 'bathrooms',
            label: 'How many bathrooms do you want?',
            type: 'select',
            options: ['0', '1', '2+'],
        },
        {
            name: 'laundry_area',
            label: 'Need laundry area?',
            type: 'select',
            options: ['Yes', 'No', 'Existing only'],
        },
        {
            name: 'separate_entrance',
            label: 'Separate entrance needed?',
            type: 'select',
            options: ['Yes', 'No', 'Already exists'],
        },
        {
            name: 'permits_needed',
            label: 'Do you need permits/help with legal secondary unit planning?',
            type: 'select',
            options: ['Yes', 'No', 'Not sure'],
        },
        {
            name: 'water_damage',
            label: 'Any past moisture, leaks, or flooding?',
            type: 'select',
            options: ['Yes', 'No', 'Not sure'],
        },
        {
            name: 'insulation_needed',
            label: 'Need insulation and framing?',
            type: 'select',
            options: ['Yes', 'No', 'Not sure'],
        },
        {
            name: 'flooring_type',
            label: 'Preferred flooring',
            type: 'select',
            options: ['Vinyl', 'Laminate', 'Tile', 'Carpet', 'Not sure'],
        },
        {
            name: 'timeline',
            label: 'When do you want to start?',
            type: 'select',
            options: ['ASAP', 'Within 1 month', '1-3 months', 'Just planning'],
        },
        {
            name: 'budget',
            label: 'Estimated budget',
            type: 'select',
            options: ['Under $20,000', '$20,000-$40,000', '$40,000-$70,000', '$70,000+', 'Not sure'],
        },
    ],
    'Bathroom Renovation': [
        {
            name: 'bathroom_type',
            label: 'Bathroom type',
            type: 'select',
            options: ['Powder room', 'Full bathroom', 'Ensuite', 'Basement bathroom'],
        },
        { name: 'size', label: 'Approximate size', type: 'select', options: ['Small', 'Medium', 'Large', 'Not sure'] },
        {
            name: 'full_remodel',
            label: 'What do you need?',
            type: 'select',
            options: ['Full remodel', 'Tub to shower conversion', 'Tile only', 'Vanity/toilet replacement', 'Repairs'],
        },
        {
            name: 'layout_changes',
            label: 'Changing layout or plumbing locations?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'tub_or_shower',
            label: 'Main fixture',
            type: 'select',
            options: ['Walk-in shower', 'Bathtub', 'Tub and shower combo', 'Not sure'],
        },
        {
            name: 'glass_door',
            label: 'Need glass shower door?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'tile_scope',
            label: 'Tile scope',
            type: 'select',
            options: ['Floor only', 'Walls only', 'Floor and walls', 'Full shower surround'],
        },
        {
            name: 'waterproofing',
            label: 'Need full waterproofing system?',
            type: 'select',
            options: ['Yes', 'No', 'Not sure'],
        },
        {
            name: 'fixtures_supplied',
            label: 'Who will supply fixtures/materials?',
            type: 'select',
            options: ['Client', 'Contractor', 'Mixed'],
        },
        {
            name: 'current_issues',
            label: 'Any current issues?',
            type: 'checkbox',
            options: ['Leak', 'Mold', 'Broken tiles', 'Old caulking', 'Poor ventilation', 'Water damage'],
            fullWidth: true,
        },
        {
            name: 'timeline',
            label: 'Preferred timeline',
            type: 'select',
            options: ['ASAP', 'Within 1 month', '1-3 months', 'Just planning'],
        },
        {
            name: 'budget',
            label: 'Estimated budget',
            type: 'select',
            options: ['Under $8,000', '$8,000-$15,000', '$15,000-$25,000', '$25,000+', 'Not sure'],
        },
    ],
    'Kitchen Renovation': [
        {
            name: 'kitchen_size',
            label: 'Kitchen size',
            type: 'select',
            options: ['Small', 'Medium', 'Large', 'Open concept'],
        },
        {
            name: 'full_or_partial',
            label: 'Project scope',
            type: 'select',
            options: ['Full renovation', 'Cabinet refacing', 'Cabinet replacement', 'Countertops only', 'Backsplash only', 'Repairs'],
        },
        {
            name: 'layout_changes',
            label: 'Changing layout?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'new_cabinets',
            label: 'Need new cabinets?',
            type: 'select',
            options: ['Yes', 'No', 'Refacing only'],
        },
        {
            name: 'countertops',
            label: 'Countertop preference',
            type: 'select',
            options: ['Quartz', 'Laminate', 'Granite', 'Porcelain', 'Not sure'],
        },
        { name: 'backsplash', label: 'Need backsplash?', type: 'select', options: ['Yes', 'No'] },
        { name: 'island', label: 'Add or replace island?', type: 'select', options: ['Yes', 'No', 'Maybe'] },
        {
            name: 'appliances',
            label: 'Appliances',
            type: 'select',
            options: ['Keeping existing', 'Replacing', 'Need installation only'],
        },
        {
            name: 'electrical_changes',
            label: 'Need lighting/outlet changes?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'plumbing_changes',
            label: 'Moving sink/dishwasher lines?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'flooring',
            label: 'Need new flooring too?',
            type: 'select',
            options: ['Yes', 'No', 'Maybe'],
        },
        {
            name: 'materials_supplied',
            label: 'Who supplies materials?',
            type: 'select',
            options: ['Client', 'Contractor', 'Mixed'],
        },
        {
            name: 'timeline',
            label: 'Preferred timeline',
            type: 'select',
            options: ['ASAP', 'Within 1 month', '1-3 months', 'Just planning'],
        },
        {
            name: 'budget',
            label: 'Estimated budget',
            type: 'select',
            options: ['Under $15,000', '$15,000-$30,000', '$30,000-$50,000', '$50,000+', 'Not sure'],
        },
    ],
};

export class ApplicationForm {
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

            this.initializeDynamicFields(formElement);

            formElement.addEventListener('submit', (event) => {
                event.preventDefault();

                void this.submit(formElement);
            });
        });
    }

    private initializeDynamicFields(formElement: HTMLFormElement): void {
        const projectTypeElement = formElement.querySelector<HTMLSelectElement>(PROJECT_TYPE_SELECTOR);

        this.renderDynamicFields(formElement);

        if (projectTypeElement === null) {
            return;
        }

        projectTypeElement.addEventListener('change', () => {
            this.renderDynamicFields(formElement);
        });
    }

    private renderDynamicFields(formElement: HTMLFormElement): void {
        const projectTypeElement = formElement.querySelector<HTMLSelectElement>(PROJECT_TYPE_SELECTOR);
        const dynamicFieldsElement = formElement.querySelector<HTMLElement>(DYNAMIC_FIELDS_SELECTOR);

        if (projectTypeElement === null || dynamicFieldsElement === null) {
            return;
        }

        dynamicFieldsElement.replaceChildren();

        const fields = TYPE_FIELDS_CONFIG[projectTypeElement.value] ?? [];

        fields.forEach((field) => {
            dynamicFieldsElement.append(this.createDynamicFieldElement(field));
        });
    }

    private createDynamicFieldElement(field: DynamicField): HTMLElement {
        const wrapper = document.createElement('div');
        wrapper.className = 'application-form__field';

        if (field.fullWidth === true || field.type === 'textarea' || field.type === 'checkbox') {
            wrapper.classList.add('application-form__field--full');
        }

        const label = document.createElement('label');
        label.className = 'application-form__label';
        label.htmlFor = field.name;
        label.textContent = field.label;
        wrapper.append(label);

        if (field.type === 'select') {
            wrapper.append(this.createSelectField(field));

            return wrapper;
        }

        if (field.type === 'textarea') {
            const textarea = document.createElement('textarea');
            textarea.id = field.name;
            textarea.name = field.name;
            textarea.className = 'application-form__control application-form__control--textarea';
            wrapper.append(textarea);

            return wrapper;
        }

        if (field.type === 'checkbox') {
            wrapper.append(this.createCheckboxField(field));

            return wrapper;
        }

        const input = document.createElement('input');
        input.id = field.name;
        input.name = field.name;
        input.type = field.type;
        input.className = 'application-form__control';
        wrapper.append(input);

        return wrapper;
    }

    private createSelectField(field: DynamicField): HTMLSelectElement {
        const select = document.createElement('select');
        select.id = field.name;
        select.name = field.name;
        select.className = 'application-form__control';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Select option';
        select.append(defaultOption);

        (field.options ?? []).forEach((optionValue) => {
            const optionElement = document.createElement('option');
            optionElement.value = optionValue;
            optionElement.textContent = optionValue;
            select.append(optionElement);
        });

        return select;
    }

    private createCheckboxField(field: DynamicField): HTMLElement {
        const container = document.createElement('div');
        container.className = 'application-form__checkbox-group';

        (field.options ?? []).forEach((optionValue) => {
            const optionLabel = document.createElement('label');
            optionLabel.className = 'application-form__checkbox-option';

            const input = document.createElement('input');
            input.type = 'checkbox';
            input.name = `${field.name}[]`;
            input.value = optionValue;
            input.className = 'application-form__checkbox-input';

            const text = document.createElement('span');
            text.textContent = optionValue;

            optionLabel.append(input, text);
            container.append(optionLabel);
        });

        return container;
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

        this.setStatus(formElement, 'Sending application...', 'idle');

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
                throw new Error(message ?? 'Application could not be sent.');
            }

            formElement.reset();
            this.renderDynamicFields(formElement);
            this.setStatus(formElement, message ?? 'Application sent successfully.', 'success');
        } catch (error) {
            const fallbackMessage = 'Application could not be sent.';
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

    private setStatus(formElement: HTMLFormElement, message: string, state: SubmitState): void {
        const statusElement = formElement.querySelector<HTMLElement>(this.statusSelector);

        if (statusElement === null) {
            return;
        }

        statusElement.dataset.state = state;
        statusElement.textContent = message;
    }
}
