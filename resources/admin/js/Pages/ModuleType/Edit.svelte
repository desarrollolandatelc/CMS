<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let moduleType;

    const form = useForm({
        name: moduleType.name,
        alias: moduleType.alias,
        module_name: moduleType.module_name,
        status: moduleType.status,
    });

    const submit = () => {
        $form.put(route("module-types.update", moduleType.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Tipo de módulo actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar tipo de módulo</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
