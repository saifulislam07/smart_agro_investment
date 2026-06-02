import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('[data-project-filter]');
    const projectCards = document.querySelectorAll('[data-project-status]');

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.projectFilter;

            filterButtons.forEach((item) => item.classList.remove('active'));
            button.classList.add('active');

            projectCards.forEach((card) => {
                const shouldShow = filter === 'all' || card.dataset.projectStatus === filter;
                card.classList.toggle('d-none', !shouldShow);
            });
        });
    });
});
