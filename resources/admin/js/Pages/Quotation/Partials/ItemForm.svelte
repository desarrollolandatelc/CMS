<script>
    import axios from "axios";

    import { Input, Label } from "flowbite-svelte";
    import WindowTable from "../../../Components/Core/WindowTable.svelte";
    import { client_id } from "./helper";
    import CalcTotal from "./CalcTotal.svelte";
    import TableFormat from "./Product/TableFormat.svelte";
    import ModalButton from "../../../Components/Gui/ModalButton.svelte";
    import { SearchSolid } from "flowbite-svelte-icons";

    import { onMount } from "svelte";

    export let detail = {};

    let defaultModal = false;

    const formato = new Intl.NumberFormat("es-CO", {
        maximumFractionDigits: 2,
        currency: "COP",
        style: "currency",
    });

    const selected = (event) => {
        detail.barcode = event.detail.barcode;
        detail.title = event.detail.title.name;
        detail.price = parseInt(event.detail.price);
        detail.quantity = 1;
        const provider_id = event.detail.provider.id;
        defaultModal = false;
        searchDiscount(provider_id);
    };

    const searchDiscount = (provider_id) => {
        axios
            .get(
                route("clients.get-discount", {
                    client_id: $client_id,
                    provider_id: provider_id,
                }),
            )
            .then((response) => {
                detail.discount = response.data;
            });
    };

    onMount(() => {
        if (detail.barcode === undefined) {
            detail = {
                barcode: "",
                title: "",
                price: 0,
                discount: 0,
                total: 0,
                quantity: 1,
            };
        }
    });
</script>

<div class="grid md:grid-cols-4 gap-2 mt-4">
    <div>
        <Label>Cód. barras</Label>
        <div class="flex items-center">
            <span>{detail.barcode}</span>
            <ModalButton bind:defaultModal>
                <SearchSolid slot="button-title"></SearchSolid>
                <WindowTable
                    COMPONENT={TableFormat}
                    searchRoute="products.search"
                    table="products"
                    on:change={selected}
                ></WindowTable>
            </ModalButton>
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
        <Input type="number" bind:value={detail.quantity} min="1" max="1000" />
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
