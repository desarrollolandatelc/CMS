<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let quotation;

    const form = useForm({
        id: quotation.id,
        user_id: quotation.user_id,
        client_id: quotation.client_id,
        status: quotation.status,
        details: quotation.details,
        user: quotation.user,
        client: quotation.client,
    });

    const submit = () => {
        $form.put(route("quotations.update", client.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Cotización actualizada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar cotización</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
