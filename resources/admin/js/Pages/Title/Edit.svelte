<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let title;

    const form = useForm({
        name: title.name,
        alias: title.alias,
        status: title.status,
    });

    const submit = () => {
        $form.put(route("titles.update", title.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Título actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar título</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
