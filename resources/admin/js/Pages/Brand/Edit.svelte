<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let brand;

    const form = useForm({
        name: brand.name,
        alias: brand.alias,
        status: brand.status,
    });

    const submit = () => {
        $form.put(route("brands.update", brand.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Marca actualizada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar marca</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
