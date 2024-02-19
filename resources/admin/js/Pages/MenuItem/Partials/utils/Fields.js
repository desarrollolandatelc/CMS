import { Input } from "flowbite-svelte";
import ProductTableFormat from "../Chose/ProductTableFormat.svelte";
import Resource from "../Chose/Resource.svelte";

export const fields = {
    Text: {
        component: Input,
        tableFormat: null
    },
    InputAction:{
        component: Resource,
        tableFormat: {
            products: ProductTableFormat
        }
    }
    
}