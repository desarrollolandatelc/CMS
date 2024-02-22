<script>
    import Table from "../../../Components/Gui/Table.svelte";
    import ModalBodyTableCells from "../../Product/Partials/ModalBodyTableCells.svelte";
    export let data;
    export let extraProps = null;
</script>

<Table
    {data}
    BODY_FORMAT_TABLE={extraProps.modalComponent}
    hasBulkAction={false}
    on:change
></Table>
