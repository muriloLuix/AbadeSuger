if (window.innerWidth < 768) {
    document.querySelectorAll('.card-link').forEach(cardLink => {
        cardLink.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelectorAll('.card').forEach(card => {
                card.classList.remove('selected');
            });

            this.querySelector('.card').classList.add('selected');
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('selected'));

                card.classList.add('selected');

                card.parentElement.parentElement.appendChild(card.parentElement);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.card');
        const cardClicks = new Map();

        cards.forEach(card => {
            const link = card.parentElement.href;

            card.addEventListener('click', () => {
                if (!cardClicks.has(card)) {
                    cardClicks.set(card, 0);
                }

                const clicks = cardClicks.get(card) + 1;
                cardClicks.set(card, clicks);

                if (clicks === 2) {
                    window.location.href = link;
                } else {
                    cards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');

                    const container = card.parentElement.parentElement;
                    container.appendChild(card.parentElement);
                }
            });
        });
    });
}
