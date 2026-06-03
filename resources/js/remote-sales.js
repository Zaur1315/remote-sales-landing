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

    applicationForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        clearFieldErrors();
        hideAlert(successAlert);
        hideAlert(errorAlert);
        setLoading(true);

        const formData = new FormData(applicationForm);

        try {
            const response = await fetch(applicationForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const payload = await response.json();

            if (!response.ok) {
                if (response.status === 422 && payload.errors) {
                    showValidationErrors(payload.errors);
                    showAlert(errorAlert, 'Please check the highlighted fields and try again.');
                    return;
                }

                showAlert(errorAlert, payload.message || 'Something went wrong. Please try again.');
                return;
            }

            applicationForm.reset();
            showAlert(successAlert, payload.message || 'Your application has been submitted successfully.');

            successAlert?.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            });
        } catch (error) {
            showAlert(errorAlert, 'Network error. Please check your connection and try again.');
        } finally {
            setLoading(false);
        }
    });
};

window.addEventListener('scroll', updateHeaderState, {passive: true});
window.addEventListener('load', () => {
    updateHeaderState();
    initRevealAnimations();
    initAjaxForm();
});
