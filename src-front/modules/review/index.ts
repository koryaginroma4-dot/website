import { ReviewForm } from './review-form';

const REVIEW_FORM_SELECTOR = '#review-form';
const REVIEW_FORM_STATUS_SELECTOR = '.review-form__status';

new ReviewForm(
    REVIEW_FORM_SELECTOR,
    REVIEW_FORM_STATUS_SELECTOR
).init();
