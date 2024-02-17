<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm, page } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        id: 0,
        user_id: "",
        client_id: $page.props.auth.client?.id ?? "",
        status: "pending",
        details: [],
        user: {
            id: "",
            name: "",
        },
        client: {
            id: "",
            name: "",
        },
    });

    const submit = () => {
        $form.post(route("quotations.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Cotización creada con éxito",
                });
            },
        });
    };
</script>

<AuthenticatedLayout>
    {JSON.stringify($page.props.auth)}
    <Heading tag="h3" class="mb-4">Registrar cotización</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
