window.addEventListener('DOMContentLoaded', function () {
    const savedSection = sessionStorage.getItem('activeSection');

    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    
    const activeLink = document.querySelector(`a[href="${savedSection}"]`);
    
    if (activeLink) {
        activeLink.classList.add('active');
        const parent = activeLink.closest('.nav-item')
        const dropdownMenu = activeLink.closest('.dropdown-menu')
        const splitSection = savedSection.split('/');

        if(parent.classList.contains('dropdown')){
            
            dropdownMenu.classList.add('show');
            const dropdown = this.document.getElementById(splitSection[1]);
            dropdown.setAttribute('aria-expanded','true');
            dropdown.classList.add('show','active');
            

        }
        
        
    }
});

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
        
          if (this.classList.contains('dropdown-toggle')) {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            return;
        }

        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

        this.classList.add('active');
        const href = this.getAttribute('href');
        const section = this.getAttribute('href').replace('#', '');
        sessionStorage.setItem('activeSection', section);
        window.location.href = href;


        console.log('Sección guardada:', section);
    });
});