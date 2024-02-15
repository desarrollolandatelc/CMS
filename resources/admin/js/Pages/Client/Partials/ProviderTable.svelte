<script>
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import Table from "../../Provider/Partials/Table.svelte";
    let route = window.route;
</script>

<WindowTable COMPONENT={Table} url={route("providers.search")} on:change></WindowTable>
