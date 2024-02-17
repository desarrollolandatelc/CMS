<script>
    export let discount = 0;
    export let quantity = 0;
    export let price = 0;
    const formato = new Intl.NumberFormat("es-CO", {
        maximumFractionDigits: 2,
        currency: "COP",
        style: "currency",
    });

    $: total = price * quantity * (1 - discount / 100);
</script>

<span>{formato.format(total)}"</span>
