<?php

include __DIR__.'/app.php';
include __DIR__.'/../packages/auth/class/2fa.php';
include __DIR__.'/../database/backup.php';
include __DIR__.'/../commands/bootstrap/console.php';
include __DIR__.'/../commands/class/command.php';
include __DIR__.'/../commands/class/process.php';
include __DIR__.'/../commands/commands/about.php';
include __DIR__.'/../commands/commands/api-install.php';
include __DIR__.'/../commands/commands/auth-install.php';
include __DIR__.'/../commands/commands/bills-table.php';
include __DIR__.'/../commands/commands/cart-table.php';
include __DIR__.'/../commands/commands/config-show.php';
include __DIR__.'/../commands/commands/db-backup.php';
include __DIR__.'/../commands/commands/db-show.php';
include __DIR__.'/../commands/commands/db-table.php';
include __DIR__.'/../commands/commands/db-wipe.php';
include __DIR__.'/../commands/commands/docs.php';
include __DIR__.'/../commands/commands/down.php';
include __DIR__.'/../commands/commands/env.php';
include __DIR__.'/../commands/commands/feature-purge.php';
include __DIR__.'/../commands/commands/feature-table.php';
include __DIR__.'/../commands/commands/health.php';
include __DIR__.'/../commands/commands/inspire.php';
include __DIR__.'/../commands/commands/language-table.php';
include __DIR__.'/../commands/commands/logs-clean.php';
include __DIR__.'/../commands/commands/logs-table.php';
include __DIR__.'/../commands/commands/make-chart.php';
include __DIR__.'/../commands/commands/make-command.php';
include __DIR__.'/../commands/commands/make-controller.php';
include __DIR__.'/../commands/commands/make-database.php';
include __DIR__.'/../commands/commands/make-excel.php';
include __DIR__.'/../commands/commands/make-exception.php';
include __DIR__.'/../commands/commands/make-feature.php';
include __DIR__.'/../commands/commands/make-job.php';
include __DIR__.'/../commands/commands/make-mail.php';
include __DIR__.'/../commands/commands/make-middleware.php';
include __DIR__.'/../commands/commands/make-migration.php';
include __DIR__.'/../commands/commands/make-model.php';
include __DIR__.'/../commands/commands/make-notification.php';
include __DIR__.'/../commands/commands/make-pdf.php';
include __DIR__.'/../commands/commands/make-resource.php';
include __DIR__.'/../commands/commands/make-rule.php';
include __DIR__.'/../commands/commands/make-test.php';
include __DIR__.'/../commands/commands/make-validation.php';
include __DIR__.'/../commands/commands/migrate.php';
include __DIR__.'/../commands/commands/migrate-refresh.php';
include __DIR__.'/../commands/commands/migrate-reset.php';
include __DIR__.'/../commands/commands/migrate-rollback.php';
include __DIR__.'/../commands/commands/migrate-status.php';
include __DIR__.'/../commands/commands/model-show.php';
include __DIR__.'/../commands/commands/model-status-table.php';
include __DIR__.'/../commands/commands/monitor-table.php';
include __DIR__.'/../commands/commands/notifications-table.php';
include __DIR__.'/../commands/commands/pail.php';
include __DIR__.'/../commands/commands/permissions-create-permission.php';
include __DIR__.'/../commands/commands/permissions-create-role.php';
include __DIR__.'/../commands/commands/permissions-show.php';
include __DIR__.'/../commands/commands/permissions-table.php';
include __DIR__.'/../commands/commands/pint.php';
include __DIR__.'/../commands/commands/queue-clear.php';
include __DIR__.'/../commands/commands/queue-failed.php';
include __DIR__.'/../commands/commands/queue-flush.php';
include __DIR__.'/../commands/commands/queue-retry.php';
include __DIR__.'/../commands/commands/queue-table.php';
include __DIR__.'/../commands/commands/queue-work.php';
include __DIR__.'/../commands/commands/route-list.php';
include __DIR__.'/../commands/commands/server.php';
include __DIR__.'/../commands/commands/session-table.php';
include __DIR__.'/../commands/commands/shell.php';
include __DIR__.'/../commands/commands/test.php';
include __DIR__.'/../commands/commands/tokens-table.php';
include __DIR__.'/../commands/commands/up.php';
include __DIR__.'/../commands/commands/vendor-publish.php';
include __DIR__.'/../commands/commands/view-clear.php';
include __DIR__.'/../commands/commands/visits-table.php';

include __DIR__.'/../packages/export/excel.php';
include __DIR__.'/../packages/export/pdf.php';

include __DIR__.'/../packages/feature/class/feature.php';

include __DIR__.'/../packages/health/class/health.php';

include __DIR__.'/../http/redirect.php';
include __DIR__.'/../http/request.php';
include __DIR__.'/../http/resources.php';
include __DIR__.'/../http/response.php';

include __DIR__.'/../routing/router.php';
include __DIR__.'/../routing/route.php';
include __DIR__.'/../routing/controller.php';
include __DIR__.'/../routing/base-controller.php';

include __DIR__.'/../database/soft-deletes.php';
include __DIR__.'/../database/has-relationships.php';
include __DIR__.'/../database/base-model.php';
include __DIR__.'/../database/migration.php';

include __DIR__.'/../pagination/paginator.php';
include __DIR__.'/../pagination/length-aware-paginator.php';

include __DIR__.'/../database/builder.php';
include __DIR__.'/../view/view-service-provider.php';

include __DIR__.'/../database/db.php';
include __DIR__.'/../database/model.php';
include __DIR__.'/../database/searchable.php';

include __DIR__.'/../jobs/class/job.php';

include __DIR__.'/../lang/class/lang.php';
include __DIR__.'/../lang/models/language.php';

include __DIR__.'/../packages/logs/traits/logs.php';

include __DIR__.'/../packages/model-status/models/model-status.php';
include __DIR__.'/../packages/model-status/traits/has-model-status.php';

include __DIR__.'/../packages/monitor/class/monitor.php';
include __DIR__.'/../packages/monitor/controllers/monitor.php';
include __DIR__.'/../packages/monitor/middleware/monitor.php';
include __DIR__.'/../packages/monitor/models/monitor.php';

include __DIR__.'/../packages/permissions/middleware/can.php';
include __DIR__.'/../packages/permissions/models/permission.php';
include __DIR__.'/../packages/permissions/models/role.php';
include __DIR__.'/../packages/permissions/traits/has-role.php';

include __DIR__.'/../notifications/traits/notifiable.php';
include __DIR__.'/../notifications/class/notification.php';

include __DIR__.'/../packages/social/facebook.php';
include __DIR__.'/../packages/social/google.php';

include __DIR__.'/../packages/tokens/middleware/token-based-auth.php';
include __DIR__.'/../packages/tokens/models/token.php';
include __DIR__.'/../packages/tokens/traits/has-tokens.php';

include __DIR__.'/../packages/visits/traits/has-visits.php';

include __DIR__.'/../validations/class/rule.php';
include __DIR__.'/../validations/class/validation.php';
include __DIR__.'/../validations/interfaces/rule.php';

include __DIR__.'/../test/test.php';

include __DIR__.'/../view/illuminate-component-tag-compiler.php';
include __DIR__.'/../view/component-tag-compiler.php';
include __DIR__.'/../view/compiler.php';
include __DIR__.'/../view/provider-view-service-provider.php';
include __DIR__.'/../view/provider-service-provider.php';
include __DIR__.'/../view/componentes.php';

include __DIR__.'/../support/class/bing-ai.php';
include __DIR__.'/../support/class/cart.php';
include __DIR__.'/../support/class/database-based-session.php';
include __DIR__.'/../support/class/gemini.php';
include __DIR__.'/../support/class/mail.php';
include __DIR__.'/../support/class/openai.php';
include __DIR__.'/../support/class/qr.php';
include __DIR__.'/../support/class/session.php';
include __DIR__.'/../support/class/ssh.php';
include __DIR__.'/../support/class/storage.php';
include __DIR__.'/../support/functions/config.php';
include __DIR__.'/../support/functions/date.php';
include __DIR__.'/../support/functions/debug.php';
include __DIR__.'/../support/functions/helpers.php';
include __DIR__.'/../support/functions/json.php';
include __DIR__.'/../support/functions/selected.php';
include __DIR__.'/../support/functions/var.php';

include __DIR__.'/../view/view.php';
include __DIR__.'/../view/assets.php';

include __DIR__.'/../packages/bill/models/bill-item.php';
include __DIR__.'/../packages/bill/models/bill.php';
include __DIR__.'/../packages/bill/models/customer.php';
include __DIR__.'/../packages/bill/traits/billable.php';

include __DIR__.'/../packages/cash-converter/cash-converter.php';

include __DIR__.'/../packages/chart/chart.php';

include __DIR__.'/../packages/crud/traits/crud.php';
