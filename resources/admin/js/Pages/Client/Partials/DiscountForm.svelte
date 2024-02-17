<script lang="ts">
    import { Input, Label } from "flowbite-svelte";
    import InputAction from "../../../Components/Gui/InputAction.svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import { onMount } from "svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import TableFormat from "./TableFormat.svelte";

    const route = window.route;

    export let detail: DiscountFormData = null;
    let defaultModal: boolean = false;

    const selected = (event) => {
        detail.provider.id = event.detail.id;
        detail.provider.name = event.detail.name;

        defaultModal = false;
    };

    onMount(() => {
        if (!detail.provider || detail.provider.id == null) {
            detail = {
                provider: {
                    id: null,
                    name: null,
                },
                percentage: null,
            };
        }
    });
</script>

{#if detail.provider}
    <div class="grid md:grid-cols-2 gap-4 mt-4">
        <div>
            <Label>Proveedor</Label>
            <InputAction value={detail.provider.name} bind:defaultModal>
                <SearchSolid slot="button-title" />
                <WindowTable
                    COMPONENT={TableFormat}
                    searchRoute="providers.search"
                    table="providers"
                    on:change={selected}
                ></WindowTable>
            </InputAction>
        </div>
        <div>
            <Label>Porcentaje</Label>
            <Input
                placeholder="Porcentaje %"
                type="number"
                bind:value={detail.percentage}
            />
        </div>
    </div>
{/if}
