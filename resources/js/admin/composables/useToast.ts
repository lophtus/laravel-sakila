import { useToasted } from "@hoppscotch/vue-toasted";

export default function useToast() {
  const toasted = useToasted();

  const position = 'bottom-right';
  const duration = 2000;

  function toastSuccess (message: string) {
    return toasted.show(message,
      {
        position,
        duration,
        type: "success",
        icon: "icon cil-check-circle me-2",
      }
    );
  }

  function toastError (message: string) {
    return toasted.show(message,
      {
        position,
        duration,
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
