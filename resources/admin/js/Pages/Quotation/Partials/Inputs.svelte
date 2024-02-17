<script>
    import { Button, Card, Heading, Helper, Select } from "flowbite-svelte";
    import { page } from "@inertiajs/svelte";

    import Repeater from "../../../Components/Gui/Repeater.svelte";
    import Client from "./Client/Client.svelte";
    import Seller from "./User/Seller.svelte";
    import ItemForm from "./ItemForm.svelte";
    import SavedItemForm from "./SavedItemForm.svelte";

    import { onMount } from "svelte";

    export let form;
    let repeaterComponent = null;

    let statusAvailable = {
        pending: "Pendiente",
        accepted: "Aceptado",
        rejected: "Rechazado",
    };

    const formato = new Intl.NumberFormat("es-CO", {
        maximumFractionDigits: 2,
        currency: "COP",
        style: "currency",
    });

    $: subtotal = $form.details.reduce(
        (total, item) =>
            total + item.price * item.quantity * (1 - item.discount / 100),
        0,
    );

    onMount(() => {
        if ($form.id > 0) {
            repeaterComponent = SavedItemForm;
        } else {
            repeaterComponent = ItemForm;
        }
    });
</script>

<div class="grid md:grid-cols-3 gap-2">
    <div class="md:col-span-2">
        <Card size="xl">
            <div class="w-full grid md:grid-cols-2 gap-2 bg-white">
                <div class="w-full">
                    <Seller bind:form></Seller>
                    {#if $form.errors.user_id}
                        <Helper color="red" class="mt-2">
                            {$form.errors.client_id}
                        </Helper>
                    {/if}
                </div>
                <div class="w-full">
                    <Client bind:form></Client>
                    {#if $form.errors.client_id}
                        <Helper color="red" class="mt-2">
                            {$form.errors.client_id}
                        </Helper>
                    {/if}
                </div>
            </div>
        </Card>
        <Card size="xl">
            <div class="w-full grid md:grid-cols-3 gap-2 bg-white">
                <div>
                    <p class="font-semibold mb-1">Subtotal</p>
                    <span>{formato.format(subtotal)}</span>
                </div>
                <div>
                    <p class="font-semibold mb-1">IVA</p>
                    <span>0%</span>
                </div>
                <div>
                    <p class="font-semibold mb-1">Total</p>
                    <span>
                        {formato.format((subtotal * (1 + 0 / 100)).toFixed(2))}
                    </span>
                </div>
            </div>
        </Card>
    </div>
    <div class="md:col-span-1">
        <Card size="xl">
            <Heading tag="h4" class="border-b mb-4">Estado</Heading>
            {#if $form.id > 0 && $page.props.auth.role === "administrador" && $form.status === "pending"}
                <Select bind:value={$form.status}>
                    <option value="pending">Pendiente</option>
                    <option value="accepted">Aceptado</option>
                    <option value="rejected">Rechazado</option>
                </Select>
            {:else}
                <span>{statusAvailable[$form.status]}</span>
            {/if}
        </Card>
    </div>
    {#if $form.user_id > 0 && $form.client_id > 0}
        <div class="md:col-span-full">
            <Card size="xl">
                <Repeater
                    COMPONENT={repeaterComponent}
                    bind:values={$form.details}
                    hasDeletedButton={$form.id > 0 ? false : true}
                    hasAddItemButton={$form.id > 0 ? false : true}
                />
            </Card>
        </div>
    {/if}
</div>
<div class="flex items-center mt-4">
    <Button type="submit">Registrar</Button>
    <Button href="/admin/quotations" color="alternative" class="ml-4">
        Cancelar
    </Button>
</div>
