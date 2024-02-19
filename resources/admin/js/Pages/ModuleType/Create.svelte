<script>
    import { Heading, Toast } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        name: "",
        module_name: "",
        status: false,
    });

    const submit = () => {
        $form.post(route("module-types.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Tipo de módulo creada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    <Heading tag="h3" class="mb-4">Registrar tipo de módulo</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
