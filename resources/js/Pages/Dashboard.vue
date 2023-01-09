<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, ref, computed } from "vue";

// variables
const Productos = ref(null);
const Factura = ref({
    productos: [],
});
const productoSelected = ref(null);
const subTotalFactura = computed({
    get: () => { 
        let total = 0;
        for (let index = 0; index < Factura.value.productos.length; index++) {
            const element = Factura.value.productos[index];
            total += parseInt(element.precio)
            
        }
        return total
     },
    set: (val) => { Factura.value.productos = val }
})
const IvasubTotalFactura = computed({
    get: () => { 
        let total = 0;
        let impuesto = 0;
        for (let index = 0; index < Factura.value.productos.length; index++) {
            const element = Factura.value.productos[index];
            total += parseInt(element.precio)
            impuesto += ( (total * parseInt(element.impuesto)) / 100)
            
        }
        return impuesto
     },
    set: (val) => { Factura.value.productos = val }
})
const TotalFactura = computed({
    get: () => { 
        let total = 0;
        let impuesto = 0;
        let totaltotal = 0;
        for (let index = 0; index < Factura.value.productos.length; index++) {
            const element = Factura.value.productos[index];
            total += parseInt(element.precio)
            impuesto += ( (total * parseInt(element.impuesto)) / 100)
            totaltotal += (total + impuesto )
            
        }
        return totaltotal
     },
    set: (val) => { Factura.value.productos = val }
})

// metodos
const getProductos = async () => {
    try {
        let { data } = await axios('/api/get-producto');
        Productos.value  = data
    } catch (error) {
        
    }
}


const AddFactura = async () =>{
    try {
        Factura.value.productos.push(productoSelected.value)
    } catch (error) {
        console.log(error)
    }
}

const GenerarCompra = async () => {
    try {
        let model = {
            productos: Factura.value.productos,
            sub_total: subTotalFactura.value,
            iva: IvasubTotalFactura.value,
            total: TotalFactura.value
        }

        await axios.post('/api/add-compra', model)
        Factura.value.productos = []
        productoSelected.value = null

    } catch (error) {
        console.log(error)
    }
}

onMounted(() => {
    getProductos()
});

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Compras
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <div class="flex flex-col justify-center h-full">
                            <!-- Table -->
                            <div class="w-full  mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                <header class="px-5 py-4 border-b border-gray-100">
                                    <div class="font-semibold text-gray-800">
                                        <select name="cars" id="cars" v-model="productoSelected"  >
                                            <option :value="producto" v-for="(producto, p) in Productos" :key="p" >
                                                {{ producto.producto }} / {{ producto.precio }}
                                            </option>
                                        </select>
                                        <button class="ml-5 w-auto h-auto bg-blue-500 border-t-2 "  @click="AddFactura"> agregar </button>
                                        <button class="ml-5 w-auto h-auto bg-green-500 border-t-2 "  @click="GenerarCompra"> Generar Compra </button>
                                    </div>
                                </header>

                                <div class="overflow-x-auto p-3">
                                    <table class="table-auto w-full">
                                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                            <tr>
                                                <th class="p-2">
                                                    <div class="font-semibold text-end">Descripción del producto</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-center">Cantidad</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Total</div>
                                                </th>
                                                <th class="p-2">
                                                    <div class="font-semibold text-start">Ación</div>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="text-sm divide-y divide-gray-100">
                                            <tr v-for="(prod_factura, pf) in Factura.productos" :key="pf" >
                                                <td class="p-2">
                                                    <div class="font-medium text-gray-800 text-end">
                                                        {{ prod_factura.producto }}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="text-center">1</div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="font-medium text-green-500 text-start">
                                                        $ {{prod_factura.precio}}
                                                    </div>
                                                </td>
                                                <td class="p-2">
                                                    <div class="flex justify-start">
                                                        <button>
                                                            <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- total amount -->
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>Sub-Total</div>
                                    <div class="text-blue-600">
                                        $<span>{{ subTotalFactura  }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>I.V.A</div>
                                    <div class="text-blue-600">
                                        $<span> {{ IvasubTotalFactura  }}  </span>
                                    </div>
                                </div>
                                <div class="flex justify-end font-bold space-x-4 text-2xl border-t border-gray-100 px-5 py-4">
                                    <div>TOTAL</div>
                                    <div class="text-blue-600">
                                        $<span> {{  TotalFactura  }}  </span>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <!-- send this data to backend (note: use class 'hidden' to hide this input) -->
                                    <input type="hidden" class="border border-black bg-gray-50" x-model="selected" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
