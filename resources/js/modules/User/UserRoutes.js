
import UserList from "./components/UserList";
import UserForm from "./components/UserForm";
import Login from "./components/Login";
import ProfileForm from "./components/ProfileForm";

export default [
    {
        path: "/admin/users/",
        name: "users.index",
        component: UserList,
    },
    {
        path: "/admin/users/create",
        name: "users.create",
        component: UserForm,
    },
    {
        path: "/admin/users/:user/edit",
        name: "users.edit",
        component: UserForm,
    },
    {
        path: "/admin/users/:user/profile",
        name: "users.profile",
        component: ProfileForm,
    },
    {
        path: "/auth/login/",
        name: "auth.login",
        component: Login,
        meta: {
            layout: "full",
        },
    },
];