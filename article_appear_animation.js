document.addEventListener("DOMContentLoaded", function() {
    const articles = document.querySelectorAll("article");
    let lastScrollTop = 0;

    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        return rect.top >= 0 && rect.top <= windowHeight;
    }

    function handleScroll() {
        const currentScrollTop = window.scrollY || window.pageYOffset;
        const isScrollingDown = currentScrollTop > lastScrollTop;

        if (isScrollingDown) {
            articles.forEach(article => {
                if (isInViewport(article) && !article.classList.contains("fade-in-scale")) {
                    article.classList.add("fade-in-scale");
                }
            });
        }

        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop; 
    }

  
    articles.forEach(article => {
        if (isInViewport(article)) {
            article.classList.add("fade-in-scale");
        }
    });

    window.addEventListener("scroll", handleScroll);
});

