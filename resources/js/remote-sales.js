const header = document.querySelector('[data-glass-header]');
const applicationForm = document.querySelector('[data-application-form]');
const successAlert = document.querySelector('[data-form-success]');
const errorAlert = document.querySelector('[data-form-error]');
const submitButton = document.querySelector('[data-submit-button]');
const submitText = document.querySelector('[data-submit-text]');
const submitLoader = document.querySelector('[data-submit-loader]');

const updateHeaderState = () => {
    if (!header) {
        return;
    }

    header.classList.toggle('is-scrolled', window.scrollY > 24);
};

const initRevealAnimations = () => {
    const revealElements = document.querySelectorAll('.reveal');

    if (!revealElements.length) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.14,
            rootMargin: '0px 0px -70px 0px',
        },
    );

    revealElements.forEach((element, index) => {
        element.style.transitionDelay = `${Math.min(index * 45, 240)}ms`;
        observer.observe(element);
    });
};

const clearFieldErrors = () => {
    document.querySelectorAll('[data-error-for]').forEach((element) => {
        element.textContent = '';
    });

    document.querySelectorAll('.field-group input, .field-group select, .field-group textarea').forEach((field) => {
        field.removeAttribute('aria-invalid');
    });
};

const showAlert = (element, message) => {
    if (!element) {
        return;
    }

    element.textContent = message;
    element.hidden = false;
};

const hideAlert = (element) => {
    if (!element) {
        return;
    }

    element.textContent = '';
    element.hidden = true;
};

const setLoading = (isLoading) => {
    if (!submitButton || !submitText || !submitLoader) {
        return;
    }

    submitButton.disabled = isLoading;
    submitText.hidden = isLoading;
    submitLoader.hidden = !isLoading;
};

const showValidationErrors = (errors) => {
    Object.entries(errors).forEach(([fieldName, messages]) => {
        const errorElement = document.querySelector(`[data-error-for="${fieldName}"]`);
        const fieldElement = document.querySelector(`[name="${fieldName}"]`);

        if (errorElement) {
            errorElement.textContent = Array.isArray(messages) ? messages[0] : String(messages);
        }

        if (fieldElement) {
            fieldElement.setAttribute('aria-invalid', 'true');
        }
    });
};

const initAjaxForm = () => {
    if (!applicationForm) {
        return;
    }

    applicationForm.querySelectorAll('input, select, textarea').forEach((field) => {
        field.addEventListener('input', () => {
            const fieldName = field.getAttribute('name');
            const errorElement = document.querySelector(`[data-error-for="${fieldName}"]`);

            field.removeAttribute('aria-invalid');

            if (errorElement) {
                errorElement.textContent = '';
            }

            hideAlert(errorAlert);
        });
    });

    applicationForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        clearFieldErrors();
        hideAlert(successAlert);
        hideAlert(errorAlert);

        if (!validateRequiredFields()) {
            showAlert(errorAlert, 'Please fill in all required fields.');
            return;
        }

        setLoading(true);

        const formData = new FormData(applicationForm);

        try {
            const response = await fetch(applicationForm.action, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const contentType = response.headers.get('content-type') || '';
            const isJson = contentType.includes('application/json');

            const payload = isJson
                ? await response.json()
                : {message: await response.text()};

            if (response.status === 422 && payload.errors) {
                showValidationErrors(payload.errors);
                showAlert(errorAlert, 'Please check the highlighted fields and try again.');
                return;
            }

            if (response.status === 419) {
                showAlert(errorAlert, 'Your session expired. Please refresh the page and try again.');
                return;
            }

            if (!response.ok) {
                showAlert(errorAlert, payload.message || 'Something went wrong. Please try again.');
                return;
            }

            if (window.fbq && payload.meta_event_id) {
                window.fbq('track', 'Lead', {
                    content_name: 'Remote Sales Application',
                    lead_type: 'remote_sales_application',
                }, {
                    eventID: payload.meta_event_id,
                });

                console.info('[Meta Pixel] Lead event fired successfully.', {
                    event_name: 'Lead',
                    event_id: payload.meta_event_id,
                    pixel_id: window.metaPixelId || null,
                });
            } else {
                console.warn('[Meta Pixel] Lead event was not fired.', {
                    fbq_loaded: Boolean(window.fbq),
                    event_id: payload.meta_event_id || null,
                });
            }

            applicationForm.reset();

            showAlert(
                successAlert,
                payload.message || 'Your application has been submitted successfully.',
            );

            successAlert?.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            });
        } catch (error) {
            showAlert(errorAlert, 'Unable to submit the form right now. Please try again.');
        } finally {
            setLoading(false);
        }
    });
};

const validateRequiredFields = () => {
    const requiredFields = applicationForm.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach((field) => {
        const fieldName = field.getAttribute('name');
        const errorElement = document.querySelector(`[data-error-for="${fieldName}"]`);
        const fieldValue = field.value.trim();

        if (!fieldValue) {
            isValid = false;
            field.setAttribute('aria-invalid', 'true');

            if (errorElement) {
                errorElement.textContent = 'This field is required.';
            }

            return;
        }

        if (fieldName === 'telegram_username') {
            const telegramPattern = /^@?[A-Za-z0-9_]+$/;

            if (!telegramPattern.test(fieldValue)) {
                isValid = false;
                field.setAttribute('aria-invalid', 'true');

                if (errorElement) {
                    errorElement.textContent = 'Telegram username may contain only Latin letters, numbers, underscores, and an optional @ at the beginning.';
                }
            }
        }
    });

    return isValid;
};

window.addEventListener('scroll', updateHeaderState, {passive: true});
window.addEventListener('load', () => {
    updateHeaderState();
    initRevealAnimations();
    initAjaxForm();
});
