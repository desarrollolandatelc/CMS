import ProductTableFormat from "../Chose/ProductTableFormat.svelte";
import Resource from "../Chose/Resource.svelte";
import TextInput from "../Chose/TextInput.svelte";

export const fields = {
    Text: {
        component: TextInput,
        tableFormat: null
    },
    InputAction:{
        component: Resource,
        tableFormat: {
            products: ProductTableFormat
        }
    }
    
}