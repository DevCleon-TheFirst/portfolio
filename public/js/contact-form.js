        // Contact Form Submission
        const contactForm = document.getElementById('contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                
                submitButton.textContent = 'Sending...';
                submitButton.disabled = true;
                
                try {
                    const response = await fetch('/contact', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        alert('✅ Thank you for your message! I\'ll get back to you soon.');
                        this.reset();
                    } else if (response.status === 429) {
                        // Rate limit exceeded
                        alert('⏱️ Too many submissions. Please wait a while before sending another message.');
                    } else if (response.status === 422) {
                        // Validation error
                        const errors = data.errors;
                        const errorMessages = Object.values(errors).flat().join('\n');
                        alert('❌ Validation Error:\n' + errorMessages);
                    } else {
                        alert('❌ There was an error sending your message. Please try again.');
                    }
                } catch (error) {
                    alert('❌ There was an error sending your message. Please try again.');
                    console.error('Error:', error);
                } finally {
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                }
            });
        }
