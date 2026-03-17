document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('type').value = this.dataset.type;
        const input = document.getElementById('content');
        if (this.dataset.type === 'text') {
            input.placeholder = 'Paste article text here...';
        } else if (this.dataset.type === 'url') {
            input.placeholder = 'Paste article URL here...';
        } else if (this.dataset.type === 'video') {
            input.placeholder = 'Paste video link (YouTube, etc.)...';
        }
    });
});