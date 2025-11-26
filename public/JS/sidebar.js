        window.addEventListener('DOMContentLoaded', function() {
            const savedSection = sessionStorage.getItem('activeSection') || 'dashboard';
            
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            
            const activeLink = document.querySelector(`a[href="#${savedSection}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                
                this.classList.add('active');
                
                const section = this.getAttribute('href').replace('#', '');
                sessionStorage.setItem('activeSection', section);
                
                console.log('Sección guardada:', section);
            });
        });