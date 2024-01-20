export const vNoAnimation = {
    mounted: (el) => {
        setTimeout(() => {
            el.classList.remove('no-animation')
        }, 500)
    }
}
