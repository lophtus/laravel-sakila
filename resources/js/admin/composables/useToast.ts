import { useToasted } from "@hoppscotch/vue-toasted";

export default function useToast() {
  const toasted = useToasted();

  function toastSuccess (message: string) {
    return toasted.show(message,
      {
        duration: 2000,
        type: "success",
        icon: "icon cil-check-circle me-2",
      }
    );
  }

  function toastError (message: string) {
    return toasted.show(message,
      {
        duration: 2000,
        type: "error",
        icon: "icon cil-x-circle me-2",
      }
    );
  }

  return {
    toastSuccess,
    toastError,
  }
}
