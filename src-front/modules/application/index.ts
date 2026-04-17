import { ApplicationForm } from './application-form';

const APPLICATION_FORM_SELECTOR = '#application-form';
const APPLICATION_FORM_STATUS_SELECTOR = '.application-form__status';

new ApplicationForm(
    APPLICATION_FORM_SELECTOR,
    APPLICATION_FORM_STATUS_SELECTOR
).init();
