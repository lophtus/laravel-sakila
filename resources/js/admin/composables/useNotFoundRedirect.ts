import { useRoute, useRouter } from "vue-router";

export default function useNotFoundRedirect() {
  const router = useRouter();
  const route = useRoute();

  function redirectToNotFound() {
    router.replace({
      name: "not-found",
      params: { pathMatch: route.path.substring(1).split('/') },
      query: route.query,
      hash: route.hash,
    });
  }

  return {
    redirectToNotFound,
  }
}
