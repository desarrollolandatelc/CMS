<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let client;

    const form = useForm({
        name: client.name,
        email: client.email,
        phone: client.phone,
        address: client.address,
        status: client.status,
        document_type_id: client.document_type_id,
        person_type_id: client.person_type_id,
        document_number: client.document_number,
        alias: client.alias,
        discounts: client.discounts,
    });

    const submit = () => {
        $form.put(route("clients.update", client.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Cliente actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar cliente</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
