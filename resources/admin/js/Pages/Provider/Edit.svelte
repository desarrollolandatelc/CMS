<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let provider;

    const form = useForm({
        name: provider.name,
        email: provider.email,
        phone: provider.phone,
        address: provider.address,
        status: provider.status,
        document_type_id: provider.document_type_id,
        person_type_id: provider.person_type_id,
        document_number: provider.document_number,
        alias: provider.alias,
    });

    const submit = () => {
        $form.put(route("providers.update", provider.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Proveedor actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar proveedor</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
