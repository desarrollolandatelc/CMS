<script>
    import { Heading, Toast } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    const form = useForm({
        sku: "",
        barcode: "",
        description: "",
        min_quantity: "",
        max_quantity: "",
        price: "",
        category_id: "",
        title_id: "",
        currency_id: "",
        brand_id: "",
        provider_id: "",
        images: [],
        fields: [],
        condition: "new",
        status: 1,

        category: {
            name: null,
        },
        title: {
            name: null,
        },
        currency: {
            name: null,
        },
        brand: {
            name: null,
        },
        provider: {
            name: null,
        },
    });

    const submit = () => {
        $form.post(route("products.store"), {
            onSuccess: () => {
                $form.reset();
                toasts.success({
                    description: "Producto creado con éxito",
                });
            },
        });
    };
</script>
<AuthenticatedLayout>
    {JSON.stringify($form)}
    <Heading tag="h3" class="mb-4">Registrar producto</Heading>
    <form on:submit|preventDefault={submit}>
        <Inputs {form}></Inputs>
    </form>

    <ToastContainer placement="bottom-right" let:data>
        <FlatToast {data} />
    </ToastContainer>
</AuthenticatedLayout>
