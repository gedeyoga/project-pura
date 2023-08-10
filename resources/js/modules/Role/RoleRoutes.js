
import RoleList from "./components/RoleList";
import RoleForm from "./components/RoleForm";

export default [
    {
        path: "/admin/roles/",
        name: "roles.index",
        component: RoleList,
    },
    {
        path: "/admin/roles/create",
        name: "roles.create",
        component: RoleForm,
    },
    {
        path: "/admin/roles/:role/edit",
        name: "roles.edit",
        component: RoleForm,
    },
];