
import PuraList from "./components/PuraList";
import PuraForm from "./components/PuraForm";

export default [
    {
        path: "/admin/puras/",
        name: "puras.index",
        component: PuraList,
    },
    {
        path: "/admin/puras/create",
        name: "puras.create",
        component: PuraForm,
    },
    {
        path: "/admin/puras/:pura/edit",
        name: "puras.edit",
        component: PuraForm,
    },
];