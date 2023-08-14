import JenisPuraList from "./components/JenisPuraList";
import JenisPuraForm from "./components/JenisPuraForm";

export default [
    {
        path: "/admin/jenis-puras/",
        name: "jenis-puras.index",
        component: JenisPuraList,
    },
    {
        path: "/admin/jenis-puras/create",
        name: "jenis-puras.create",
        component: JenisPuraForm,
    },
    {
        path: "/admin/jenis-puras/:jenis_pura/edit",
        name: "jenis-puras.edit",
        component: JenisPuraForm,
    },
];