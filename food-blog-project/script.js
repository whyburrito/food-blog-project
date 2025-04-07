function listView() {
    let rows = document.querySelectorAll(".row");
    rows.forEach(row => {
        row.classList.add("list-row");
    });
    
    let cols = document.querySelectorAll(".col-md-4");
    cols.forEach(col => {
        col.classList.add("list-col-md-4");
    });

    let cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        card.classList.add("list-card");
    });
}

function list() {
    document.getElementById("list").addEventListener("mouseover", function() {
        this.querySelector("span").textContent = "List ";
        this.style.paddingLeft = "0.5rem";
    });
    
    document.getElementById("list").addEventListener("mouseleave", function() {
        this.querySelector("span").textContent = "";
        this.style.paddingLeft = "0.5rem";
    });
}

function galleryView() {
    let rows = document.querySelectorAll(".row");
    rows.forEach(row => {
        row.classList.remove("list-row");
    });
    
    let cols = document.querySelectorAll(".col-md-4");
    cols.forEach(col => {
        col.classList.remove("list-col-md-4");
    });

    let cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        card.classList.remove("list-card");
    });
}

function gallery() {
    document.getElementById("gallery").addEventListener("mouseover", function() {
        this.querySelector("span").textContent = "Gallery ";
        this.style.paddingLeft = "0.5rem";
    });
    
    document.getElementById("gallery").addEventListener("mouseleave", function() {
        this.querySelector("span").textContent = "";
        this.style.paddingLeft = "0.5rem";
    });
}

window.onscroll = function buttons() {if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        document.getElementById("scroll").style.visibility = "visible";
        document.getElementById("new").style.visibility = "visible";
    } else if (document.body.scrollTop = 0 || document.documentElement.scrollTop < 250) {
        document.getElementById("scroll").style.visibility = "hidden";
        document.getElementById("new").style.visibility = "hidden";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    const a = document.querySelectorAll('.navbar a');
    const active = document.querySelector('.navbar a.active');
    
    window.addEventListener('scroll', function () {
        if (window.scrollY > 20) {
            navbar.style.borderBottom = "1px solid #7C5D3C";
            navbar.style.background = "#dbc7b4";
            a.forEach(item => {
                if (!item.classList.contains('active')) {
                    item.addEventListener('mouseover', function () {
                        this.style.borderTop = "3px solid #BD9A75";
                        this.style.borderBottom = "0";
                    });
                    item.addEventListener('mouseout', function () {
                        this.style.borderTop = "0";
                    });
                }
            });
            active.style.borderTop = "3px solid #7C5D3C";
            active.style.borderBottom = "0";
        } else {
            navbar.style.borderBottom = "0";
            navbar.style.background = "none";
            a.forEach(item => {
                if (!item.classList.contains('active')) {
                    item.addEventListener('mouseover', function () {
                        this.style.borderTop = "0";
                        this.style.borderBottom = "2px solid #BD9A75";
                    });
                    item.addEventListener('mouseout', function () {
                        this.style.borderBottom = "0";
                    });
                }
            });
            active.style.borderTop = "0";
            active.style.borderBottom = "2px solid #7C5D3C";
        }
    });
});

function scrollToTop() {
    document.getElementById("scroll").style.visibility = "hidden";
    window.scrollTo({top: 0, behavior: "smooth"});
}

function createPost() {;
    document.getElementById("create").addEventListener("mouseover", function() {
        this.querySelector("span").textContent = " Create new post";
        this.style.paddingRight = "0.75rem";
    });
    
    document.getElementById("create").addEventListener("mouseleave", function() {
        this.querySelector("span").textContent = "";
        this.style.paddingRight = "0.5rem";
    });
}

function back() {
    document.getElementById("back").addEventListener("mouseover", function() {
        this.querySelector("a span").textContent = "Back ";
        this.style.paddingLeft = "0.5rem";
    });
    
    document.getElementById("back").addEventListener("mouseleave", function() {
        this.querySelector("a span").textContent = "";
        this.style.paddingLeft = "0.5rem";
    });
}