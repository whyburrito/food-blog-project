function listView() {
    const container = document.getElementById('post-container');
    if (container) {
        document.body.classList.add('list-view');
        document.body.classList.remove('gallery-view');
        document.getElementById('list')?.classList.add('active');
        document.getElementById('gallery')?.classList.remove('active');
    }
}

function galleryView() {
     const container = document.getElementById('post-container');
    if (container) {
        document.body.classList.remove('list-view');
        document.body.classList.add('gallery-view');
        document.getElementById('gallery')?.classList.add('active');
        document.getElementById('list')?.classList.remove('active');
    }
}

function handleScrollDependentElements() {
    const scrollButton = document.getElementById("scroll");
    const navbar = document.querySelector('.navbar');
    const scrollY = window.scrollY || document.documentElement.scrollTop;

    if (scrollButton) {
        if (scrollY > 250) {
            scrollButton.classList.add('visible');
        } else {
            scrollButton.classList.remove('visible');
        }
    }

}

function scrollToTop() {
    const scrollButton = document.getElementById("scroll");
     if (scrollButton) {
        scrollButton.classList.remove('visible');
    }
    window.scrollTo({top: 0, behavior: "smooth"});
}

function setupButtonHovers() {
    const buttonsToHover = document.querySelectorAll('#list, #gallery, #create, .btn-back');

    buttonsToHover.forEach(btn => {
        if (!btn) return;
        let span = btn.querySelector("span");
        if (!span) {
            span = document.createElement('span');
            btn.appendChild(span);
        }
        const hoverText = btn.title || btn.dataset.hoverText || '';
        if (hoverText) {
            btn.addEventListener("mouseover", () => { span.textContent = ` ${hoverText}`; });
            btn.addEventListener("mouseleave", () => { span.textContent = ""; });
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {

    if (document.body.classList.contains('list-view')) {
         document.getElementById('list')?.classList.add('active');
    } else {
        document.body.classList.add('gallery-view');
        document.getElementById('gallery')?.classList.add('active');
    }

    window.addEventListener('scroll', handleScrollDependentElements);
    handleScrollDependentElements();

    const listBtn = document.getElementById('list');
    const galleryBtn = document.getElementById('gallery');
    if(listBtn) listBtn.addEventListener('click', listView);
    if(galleryBtn) galleryBtn.addEventListener('click', galleryView);

    const scrollBtn = document.getElementById('scroll');
    if(scrollBtn) scrollBtn.addEventListener('click', scrollToTop);

    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const navLinks = navbar.querySelectorAll('#menu a');
        const activeLink = navbar.querySelector('#menu a.active');

        const applyHoverStyles = (isScrolled) => {
            navLinks.forEach(item => {
                if (item !== activeLink) {
                    item.style.borderTop = "0";
                    item.style.borderBottom = "0";
                    item.onmouseover = function () {
                        this.style.borderBottom = isScrolled ? "0" : "2px solid #BD9A75";
                        this.style.borderTop = isScrolled ? "3px solid #BD9A75" : "0";
                    };
                    item.onmouseout = function () {
                        this.style.borderBottom = "0";
                        this.style.borderTop = "0";
                    };
                }
            });
            if (activeLink) {
                 activeLink.style.borderBottom = isScrolled ? "0" : "2px solid #7C5D3C";
                 activeLink.style.borderTop = isScrolled ? "3px solid #7C5D3C" : "0";
            }
        };

        window.addEventListener('scroll', function () {
             if (window.scrollY > 20) {
                navbar.style.borderBottom = "1px solid #7C5D3C";
                navbar.style.background = "#dbc7b4";
                applyHoverStyles(true);
            } else {
                navbar.style.borderBottom = "0";
                navbar.style.background = "none";
                applyHoverStyles(false);
            }
        });
         if (window.scrollY > 20) {
             navbar.style.borderBottom = "1px solid #7C5D3C";
             navbar.style.background = "#dbc7b4";
             applyHoverStyles(true);
         } else {
              applyHoverStyles(false);
         }
    }

});