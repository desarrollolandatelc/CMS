<script>
    import SelectedAction from "./SelectedAction.svelte";
    import { Input } from "flowbite-svelte";

    let query = "";
    let data = [];

    export let COMPONENT;
    export let searchRoute;
    export let table;

    $: if (query.length > 2) {
        searchData();
    } else {
        data = [];
    }

    const searchData = () => {
        axios
            .get(
                route(searchRoute, {
                    query: query,
                    table: table,
                }),
            )
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
