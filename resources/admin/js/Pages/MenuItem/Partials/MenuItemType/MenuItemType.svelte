<script>
    import { Label } from "flowbite-svelte";
    import InputAction from "../../../../Components/Gui/InputAction.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";
    import MenuTypeOptions from "./MenuTypeOptions.svelte";
    import { fields } from "../utils/Fields";

    export let form;
    let defaultModal = false;
    let field_type;
    let TableFormat;

    $: if ($form.internal_link?.field) {
        field_type = fields[$form.internal_link.field]?.component;

        const format = fields[$form.internal_link?.field]?.tableFormat;
        if (format) {
            TableFormat = format[$form.internal_link?.type];
        }
    }
    const selected = (event) => {
        $form.internal_link.name = event.detail.name;
        $form.internal_link.controller = event.detail.controller;
        $form.internal_link.field = event.detail.field;
        $form.internal_link.type = event.detail.type;
        $form.internal_link.relationship = event.detail.relationship;

        field_type = fields[event.detail.field]?.component;
        const format = fields[event.detail.field]?.tableFormat;

        if (format) {
            TableFormat = format[event.detail.type];
        }
        defaultModal = false;
    };
</script>

<Label for="email" class="block w-full">
    Tipo de menú <sup class="text-red-600">*</sup>
</Label>
<InputAction
    value={$form.internal_link?.name}
    bind:defaultModal
    modalTitle="Tipo de menú"
>
    <SearchSolid slot="button-title" />
    <MenuTypeOptions on:selected={selected} />
</InputAction>

<svelte:component this={field_type} bind:form {TableFormat} />
