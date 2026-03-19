document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.tab-btn');
    const typeInput = document.getElementById('type');
    const contentInput = document.getElementById('content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            typeInput.value = this.dataset.type;

            // Change placeholder based on tab
            const type = this.dataset.type;
            if (type === 'text') {
                contentInput.placeholder = 'Paste article text here...';
            } else if (type === 'url') {
                contentInput.placeholder = 'Paste article URL here...';
            } else if (type === 'video') {
                contentInput.placeholder = 'Paste video link (YouTube, etc.)...';
            }
        });
    });




    // --- Processing Modal Logic ---
    const analysisForm = document.querySelector('.analysis-container');
    const modal = document.getElementById('processing-modal');
    const urlDisplayText = document.getElementById('display-url-text');
    const mainProgressBar = document.getElementById('main-progress-bar');
    
    if (analysisForm) {
        analysisForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Stop normal submission

            // Get the input value and show it in the modal
            const inputValue = document.getElementById('content').value;
            urlDisplayText.textContent = inputValue ? inputValue : "Analyzing content...";

            // Show the modal
            modal.classList.add('active');

            // Define the sequence of steps
            const steps = [
                { id: 'step-1', duration: 1500, status: 'Done', progress: 25 },
                { id: 'step-2', duration: 2500, status: 'Done', progress: 50 },
                { id: 'step-3', duration: 2000, status: 'Done', progress: 75 },
                { id: 'step-4', duration: 1500, status: 'Done', progress: 100 }
            ];

            let currentStep = 0;

            function processNextStep() {
                if (currentStep > 0) {
                    // Mark previous step as completed
                    const prevStepEl = document.getElementById(steps[currentStep - 1].id);
                    prevStepEl.classList.remove('active');
                    prevStepEl.classList.add('completed');
                    prevStepEl.querySelector('.step-status').textContent = 'Done';
                }

                if (currentStep < steps.length) {
                    // Set current step to active
                    const currentStepEl = document.getElementById(steps[currentStep].id);
                    currentStepEl.classList.add('active');
                    currentStepEl.querySelector('.step-status').textContent = 'Running';
                    
                    // Update main progress bar
                    mainProgressBar.style.width = steps[currentStep].progress + '%';

                    // Wait and go to next
                    setTimeout(processNextStep, steps[currentStep].duration);
                    currentStep++;
                } else {
                    // All visual steps done, execute the real backend POST via fetch
                    submitDataToBackend();
                }
            }

            // Start the visual sequence
            processNextStep();
        });
    }

    function submitDataToBackend() {
        const formData = new FormData(analysisForm);
        
        fetch('analyze.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Since analyze.php normally returns a header redirect, 
            // fetch will follow it, but we need to manually redirect the window
            if(response.redirected) {
                window.location.href = response.url;
            } else {
                // Fallback in case redirect fails
                console.error("No redirect URL found from backend.");
            }
        })
        .catch(error => {
            console.error('Error during analysis:', error);
            alert("Connection failed. Please try again.");
            modal.classList.remove('active');
        });
    }


    // --- Accordion Toggle Logic (Results Page) ---
    const toggleButtons = document.querySelectorAll('.toggle-evidence-btn');
    
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Find the parent claim item
            const claimItem = this.closest('.claim-item');
            // Find the body within this item
            const claimBody = claimItem.querySelector('.claim-body');
            
            // Toggle visibility and update button text
            if (claimBody.style.display === 'none') {
                claimBody.style.display = 'block';
                this.innerHTML = '▲ Hide evidence';
            } else {
                claimBody.style.display = 'none';
                this.innerHTML = '▼ Show evidence';
            }
        });
    });

    // --- Copy Link functionality (Results Page) ---
    const copyLinkBtn = document.getElementById('copy-link-btn');
    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
            // Get the current page URL
            const currentUrl = window.location.href;
            
            // Use the Clipboard API to copy it
            navigator.clipboard.writeText(currentUrl).then(() => {
                // Temporarily change the text to show success
                const originalText = this.innerHTML;
                this.innerHTML = "Copied ✓";
                this.style.color = "var(--accent-green)"; // Turn it green
                
                // Change it back after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.color = "var(--accent-cyan)";
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        });
    }

    // --- Verdict Card Modal Logic ---
    const shareResultBtn = document.getElementById('share-result-btn');
    const verdictModal = document.getElementById('verdict-modal');
    const closeVerdictBtn = document.getElementById('close-verdict-btn');

    // Only run if we are on the results page and the elements exist
    if (shareResultBtn && verdictModal && closeVerdictBtn) {
        
        // Open modal
        shareResultBtn.addEventListener('click', function() {
            verdictModal.classList.add('active');
            // Prevent body scrolling while modal is open
            document.body.style.overflow = 'hidden';
        });

        // Close modal via button
        closeVerdictBtn.addEventListener('click', function() {
            verdictModal.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Close modal when clicking outside the card
        verdictModal.addEventListener('click', function(e) {
            if (e.target === verdictModal) {
                verdictModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }
});