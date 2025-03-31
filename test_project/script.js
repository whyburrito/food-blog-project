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

    let creates = document.querySelectorAll("#create");
    creates.forEach(create => {
        create.style.width = "50%";
        create.style.marginLeft = "25%";
        create.removeAttribute("onmouseover");
        create.querySelector("span").textContent = " Create new post";
    });
}

function list() {
    document.getElementById("list").addEventListener("mouseover", function() {
        this.querySelector("span").textContent = "List ";
        this.style.paddingLeft = "0.75rem";
    });
    
    document.getElementById("list").addEventListener("mouseleave", function() {
        this.querySelector("span").textContent = "";
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

    let creates = document.querySelectorAll("#create");
    creates.forEach(create => {
        create.style.width = "";
        create.style.marginLeft = "";
        create.querySelector("span").textContent = "";
        create.setAttribute("onmouseover", "createPost()");
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

window.onscroll = function buttons() {
    if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        document.getElementById("scroll").style.visibility = "visible";
        document.getElementById("new").style.visibility = "visible";
    } else if (document.body.scrollTop = 0 || document.documentElement.scrollTop < 250) {
        document.getElementById("scroll").style.visibility = "hidden";
        document.getElementById("new").style.visibility = "hidden";
    }
}

function scrollToTop() {
    document.getElementById("top").style.visibility = "hidden";
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