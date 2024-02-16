<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let category;

    const form = useForm({
        name: category.name,
        alias: category.alias,
        status: category.status,
        parent_id: category.parent_id,
        parent: category.parent,
    });

    const submit = () => {
        $form.put(route("categories.update", category.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Categoría actualizada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar categoría</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
