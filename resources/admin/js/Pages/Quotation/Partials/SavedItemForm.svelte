<script>
    import { Label } from "flowbite-svelte";
    import CalcTotal from "./CalcTotal.svelte";

    export let detail = {};

    const formato = new Intl.NumberFormat("es-CO", {
        maximumFractionDigits: 2,
        currency: "COP",
        style: "currency",
    });
</script>

<div class="grid md:grid-cols-4 gap-2 mt-4">
    <div>
        <Label>Cód. barras</Label>
        <div class="flex items-center">
            <span>{detail.barcode}</span>
        </div>
    </div>

    <div>
        <Label>Descripcion</Label>

        <span>{detail.title}</span>
    </div>
    <div>
        <Label>Precio</Label>

        <span>{detail.price}</span>
    </div>

    <div>
        <Label>Cantidad</Label>
        <span>{detail.quantity}</span>
    </div>
</div>
<div class="grid grid-cols-3 mt-4 shadow-md border p-1">
    <div>
        <p>
            Subtotal: <span class="font-bold"
                >{formato.format(detail.price * detail.quantity)}</span
            >
        </p>
    </div>

    <div>
        <p>Descuento %: <span class="font-bold">{detail.discount}</span></p>
    </div>

    <div>
        <span>
            Total:
            <CalcTotal
                discount={detail.discount}
                quantity={detail.quantity}
                price={detail.price}
            />
        </span>
    </div>
</div>
