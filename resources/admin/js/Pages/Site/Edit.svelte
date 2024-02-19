<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    import { onMount } from "svelte";

    export let site;

    const form = useForm({
        name: site.name,
        alias: site.alias,
        config: site.config,
        status: site.status,
    });

    const submit = () => {
        $form.put(route("sities.update", site.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Sitio actualizado con éxito",
                });
            },
        });
    };

    onMount(() => {
        console.log(module);
    });
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar sitio</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
