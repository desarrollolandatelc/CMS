<script>
    import SelectedAction from "./SelectedAction.svelte";
    import { Input } from "flowbite-svelte";

    let query = "";
    let data = [];

    export let COMPONENT;
    export let url;

    $: if (query.length > 2) {
        searchData();
    } else {
        data = [];
    }

    const searchData = () => {
        axios
            .get(`${url}?query=${query}`)
            .then((response) => {
                data = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };
</script>

<Input placeholder="Buscar..." bind:value={query} />
<!-- Muestra la tabla -->
<svelte:component
    this={COMPONENT}
    ACTIONS={SelectedAction}
    bind:data
    on:change
    hasDeleteAll={false}
></svelte:component>
