<script>
    import { Heading } from "flowbite-svelte";
    import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.svelte";
    import Inputs from "./Partials/Inputs.svelte";
    import { useForm } from "@inertiajs/svelte";
    import { toasts, ToastContainer, FlatToast } from "svelte-toasts";

    export let product;

    const form = useForm({
        sku: product.sku,
        barcode: product.barcode,
        description: product.description,
        min_quantity: product.min_quantity,
        max_quantity: product.max_quantity,
        price: product.price,
        category_id: product.category_id,
        title_id: product.title_id,
        currency_id: product.currency_id,
        brand_id: product.brand_id,
        provider_id: product.provider_id,
        images: product.images,
        fields: product.fields,
        condition: product.condition,
        status: product.status,
        category: product.category,
        title: product.title,
        currency: product.currency,
        brand: product.brand,
        provider: product.provider,
    });

    const submit = () => {
        $form.put(route("products.update", product.id), {
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
