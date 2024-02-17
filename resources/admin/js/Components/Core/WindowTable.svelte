<script>
    import SelectedAction from "./SelectedAction.svelte";
    import { Input } from "flowbite-svelte";

    let query = "";
    let data = [];

    export let COMPONENT;
    export let HEADER_FORMAT_TABLE = null;
    export let BODY_FORMAT_TABLE = null;
    export let searchRoute;
    export let table;
    export let searchFor = "";

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

<Input placeholder="Buscar {searchFor}" bind:value={query} />
<!-- Muestra la tabla -->
<svelte:component
    this={COMPONENT}
    {BODY_FORMAT_TABLE}
    bind:data
    on:change
    hasDeleteAll={false}
></svelte:component>
