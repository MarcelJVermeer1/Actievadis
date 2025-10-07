<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof toastr !== "undefined") {
            const messages = {
                success: "{{ session('success') }}",
                error: "{{ session('error') }}",
                warning: "{{ session('warning') }}",
                info: "{{ session('info') }}"
            };

            Object.entries(messages).forEach(([type, message]) => {
                if (message) {
                    toastr[type](message);
                }
            });
        } else {
            console.error("Toastr is not defined. Ensure it is loaded correctly.");
        }
    });
</script>