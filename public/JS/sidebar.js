        window.addEventListener('DOMContentLoaded', function() {
            const savedSection = sessionStorage.getItem('activeSection');
            
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            
            const activeLink = document.querySelector(`a[href="${savedSection}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                this.classList.add('active');
                const href = this.getAttribute('href');                
                const section = this.getAttribute('href').replace('#', '');
                sessionStorage.setItem('activeSection', section);
                window.location.href = href;
                
                
                console.log('Sección guardada:', section);
            });
        });