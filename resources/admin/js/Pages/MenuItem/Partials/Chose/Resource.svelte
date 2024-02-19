<script>
    import { Label } from "flowbite-svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import WindowTable from "../../../../Components/Core/WindowTable.svelte";

    export let form;
    export let TableFormat;
    let defaultModal = false;

    const selected = (event) => {
        console.log($form.internal_link.relationship);
        $form.internal_link.resource_name = getName(
            $form.internal_link.relationship,
            event,
        );

        $form.internal_link.resource_id = event.detail.id;
        defaultModal = false;
    };

    function getName(relation, event) {
        if (!relation) {
            return event.detail.name;
        }
        console.log(event.detail[relation].name);
        return event.detail[relation].name;
    }
</script>

<Label for="email" class="block w-full mt-4">
    Escoger recurso <sup class="text-red-600">*</sup>
</Label>
<InputAction
    value={$form.internal_link?.resource_name}
    bind:defaultModal
    modalTitle="Tipo de menú"
>
    <SearchSolid slot="button-title" />
    <WindowTable
        COMPONENT={TableFormat}
        searchRoute="{$form.internal_link.type}.search"
        table={$form.internal_link.type}
        on:change={selected}
    ></WindowTable>
</InputAction>
