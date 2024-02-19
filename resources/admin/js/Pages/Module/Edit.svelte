<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    import { onMount } from "svelte";

    export let module;

    const form = useForm({
        name: module.name,
        alias: module.alias,
        module_type_id: module.module_type_id,
        module_type: module.module_type,
        view_path: module.view_path,
        status: module.status,
    });

    const submit = () => {
        $form.put(route("modules.update", module.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Módulo actualizado con éxito",
                });
            },
        });
    };

    onMount(() => {
        console.log(module);
    });
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar módulo</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
