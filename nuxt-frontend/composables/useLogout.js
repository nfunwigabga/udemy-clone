export const useLogout = () => {
    const auth = useAuth()
    async function logout() {
        try {
          await auth.logout();
          navigateTo("/");
        } catch (error) {
            console.log(error)
        }
    }

    return { logout }
}