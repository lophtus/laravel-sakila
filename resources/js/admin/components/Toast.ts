import { useToasted } from "@hoppscotch/vue-toasted";

export function toastSuccess (message: string) {
  return useToasted().show(message,
    {
      duration: 2000,
      type: "success",
      icon: "icon cil-check-circle me-2",
    }
  );
}

export function toastError (message: string) {
  return useToasted().show(message,
    {
      duration: 2000,
      type: "error",
      icon: "icon cil-x-circle me-2",
    }
  );
}
