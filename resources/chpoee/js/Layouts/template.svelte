<script>
    import { onMount } from "svelte";
    import Header from "./partials/Header.svelte";

    onMount(() => {
        console.log("template");
        /* import("./assets/vendor/owl-carousel/owl.carousel.js");
        import("./assets/vendor/slider/slider.js");
        import("./assets/js/custom/custom.js"); */
    });
</script>

<Header></Header>
<slot />
