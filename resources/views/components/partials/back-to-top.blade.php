<div x-data="{ show: false }" x-init="window.addEventListener('scroll', () => { show = window.scrollY > 200 })">
    <button x-show="show" x-transition @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="partials_back_to_top">
        <i class="fa-solid fa-arrow-up"></i> </button>
</div>