/**
 * Highlights active navigation links based on the `data-nav-active` attribute.
 *
 * Iterates through elements with `[data-nav-active]`, compares their value
 * against each child link's `data-match`, and applies the `menu-active` class
 * to matching links.
 */
export default function activeNav() {
    const navActive = document.querySelectorAll('[data-nav-active]');
    if (!navActive.length) return; // Exit early if '[data-nav-active]' does not exist

    navActive.forEach(itemGroup => {

        const navActiveSelected = itemGroup.dataset.navActive;
        const navActiveItems    = itemGroup.querySelectorAll('a');

        navActiveItems.forEach(item => {

            const matchCriteriaString = item.dataset.match ?? '';

            if (!matchCriteriaString) return;

            const matchValues = matchCriteriaString.split(',').map(value => value.trim());
            if (matchValues.includes(navActiveSelected)) {
                item.classList.add('menu-active');
            }

        });

    });
}