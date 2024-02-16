<script lang="ts">
    import { Input, Label } from "flowbite-svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import Table from "../../Provider/Partials/Table.svelte";
    import { onMount } from "svelte";

    const route = window.route;

    export let detail = {
        field: {
            id: null,
            name: null,
        },
        value: null,
    };
    let defaultModal: boolean = false;

    const selected = (event) => {
        detail.field.id = event.detail.id;
        detail.field.name = event.detail.name;

        defaultModal = false;
    };

    onMount(() => {
        if (!detail.field || detail.field.id == null) {
            detail = {
                field: {
                    id: null,
                    name: null,
                },
                value: null,
            };
        }
    });
</script>

{#if detail.field}
    <div class="grid md:grid-cols-2 gap-4 mt-4">
        <div>
            <Label>Campo</Label>
            <InputAction value={detail.field.name} bind:defaultModal>
                <WindowTable
                    COMPONENT={Table}
                    searchRoute="fields.search"
                    table="fields"
                    on:change={selected}
                ></WindowTable>
            </InputAction>
        </div>
        <div>
            <Label>Valor</Label>
            <Input type="text" bind:value={detail.value} />
        </div>
    </div>
{/if}
