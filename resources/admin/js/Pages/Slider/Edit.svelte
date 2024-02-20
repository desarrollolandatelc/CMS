<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let slider;

    const form = useForm({
        name: slider.name,
        alias: slider.alias,
        module_id: slider.module_id,
        details: slider.details,
        description: slider.description,
        status: slider.status,
    });

    const submit = () => {
        $form.put(route("sliders.update", slider.id), {
            onSuccess: () => {
                toasts.success({
                    description: "Slider actualizado con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Actualizar slider</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>
    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
        <!-- Provider template for your toasts -->
    </ToastContainer>
</AuthenticatedLayout>
