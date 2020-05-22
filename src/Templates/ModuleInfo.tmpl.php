<?php if (!defined('LOADED_FROM_INDEX') || LOADED_FROM_INDEX != 'true') { die('Access denied.'); }?>

<?php use RobinTheHood\ModifiedModuleLoaderClient\ModuleStatus; ?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <?php include 'Head.tmpl.php' ?>
    </head>

    <body>
        <?php include 'Navi.tmpl.php' ?>

        <div class="content">
            <div class="moduleinfo">
                <div class="container">
                    <?php echo RobinTheHood\ModifiedModuleLoaderClient\Notification::renderFlashMessages() ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="module-icon">
                                <img src="<?php echo $module->getIconUri(); ?>">
                            </div>

                            <h1><?php echo $module->getName() ?></h1>

                            <?php if ($module->getImageUris()) { ?>
                                <div class="row moduleinfo-images">
                                    <?php foreach($module->getImageUris() as $image) { ?>
                                        <div class="col-3">
                                            <a href="<?php echo $image ?>" data-lightbox="show-1" data-title="<?php echo $module->getName() ?>">
                                                <img src="<?php echo $image ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if (ModuleStatus::isRepairable($module)) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>Achtung:</strong> Einige Dateien befinden sich nicht mehr im Originalzustand. Möglicherweise hast Du an diesen
                                    Anpassungen vorgenommen. <strong>Deinstallation</strong> und <strong>Update</strong> stehen dir nur bei unveränderten Modulen zur
                                    Verfügung, damit Deine Arbeit nicht verloren geht. <a href="#" onclick="$('#v-pills-files-tab').tab('show');">Alle Änderungen ansehen</a>.
                                </div>
                            <?php } ?>

                            <div class="moduleinfo-buttons">
                                <?php if (!ModuleStatus::isLoadable($module)) { ?>
                                    Keine Berechtigung zur Installation. Nimm Kontakt zum Entwickler auf.
                                <?php } ?>

                                <?php if (ModuleStatus::isUpdateable($module) && !ModuleStatus::isRepairable($module)) { ?>
                                    <a class="button button-success" href="?action=update&archiveName=<?php echo $module->getArchiveName() ?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Update installieren</a>
                                <?php } ?>

                                <?php if (ModuleStatus::isRepairable($module)) { ?>
                                    <a class="button button-warning" onclick="return confirm('Möchtest Du deine Änderungen wirklich rückgängig machen?');" href="?action=install&archiveName=<?php echo $module->getArchiveName()?>&ref=moduleInfo">Änderungen verwerfen</a>
                                <?php } ?>

                                <?php if (ModuleStatus::isCompatibleLoadebale($module)) { ?>
                                    <a class="button button-default" href="?action=loadAndInstall&archiveName=<?php echo $module->getArchiveName()?>&version=<?php echo $module->getVersion()?>&ref=moduleInfo">Download & Install</a>

                                <?php } elseif (ModuleStatus::isUncompatibleLoadebale($module)) { ?>
                                    <a class="button button-default" href="?action=loadRemoteModule&archiveName=<?php echo $module->getArchiveName()?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Download (inkompatible Version)</a>

                                <?php } elseif (ModuleStatus::isUninstallable($module) && !ModuleStatus::isRepairable($module)) { ?>
                                    <a class="button button-danger" href="?action=uninstall&archiveName=<?php echo $module->getArchiveName()?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Deinstallieren</a>

                                <?php } elseif (ModuleStatus::isCompatibleInstallable($module)) { ?>
                                    <a class="button button-success" href="?action=install&archiveName=<?php echo $module->getArchiveName() ?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Installieren</a>

                                <?php } elseif (ModuleStatus::isUncompatibleInstallable($module)) { ?>
                                    <a class="button button-success" href="?action=install&archiveName=<?php echo $module->getArchiveName() ?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Installieren (inkompatible Version)</a>
                                <?php } ?>

                                <!--
                                <?php if (!$module->isRemote() && $module->isLoaded()) { ?>
                                    <a class="button button-default" href="?action=downloadArchive&archiveName=<?php echo $module->getArchiveName()?>&ref=moduleInfo">Herunterladen (.tar)</a>
                                <?php } ?>
                                !-->

                                <?php if (!$module->isRemote() && $module->isLoaded() && !$module->isInstalled()) { ?>
                                    <a class="button button-danger" onclick="return confirm('Möchtest Du das Modul wirklich entfernen?');" href="?action=unloadLocalModule&archiveName=<?php echo $module->getArchiveName()?>&version=<?php echo $module->getVersion() ?>&ref=moduleInfo">Modul löschen</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3" style="min-height: 400px">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active show" id="v-pills-overview-tab" data-toggle="pill" href="#v-pills-overview" role="tab" aria-controls="v-pills-overview" aria-selected="true">Übersicht</a>
                                <a class="nav-link" id="v-pills-install-tab" data-toggle="pill" href="#v-pills-install" role="tab" aria-controls="v-pills-install" aria-selected="false">Installation</a>
                                <a class="nav-link" id="v-pills-usage-tab" data-toggle="pill" href="#v-pills-usage" role="tab" aria-controls="v-pills-usage" aria-selected="false">Bedienung</a>
                                <a class="nav-link" id="v-pills-changes-tab" data-toggle="pill" href="#v-pills-changes" role="tab" aria-controls="v-pills-changes" aria-selected="false">Änderungsprotokoll</a>
                                <a class="nav-link" id="v-pills-details-tab" data-toggle="pill" href="#v-pills-details" role="tab" aria-controls="v-pills-details" aria-selected="false">Details</a>
                                <?php if (ModuleStatus::isRepairable($module)) { ?>
                                    <a class="nav-link" id="v-pills-files-tab" data-toggle="pill" href="#v-pills-files" role="tab" aria-controls="v-pills-files" aria-selected="false">Geänderte Dateien</a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-9" style="border-left: 1px solid #cccccc">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade active show" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                                    <div class="infos" style="margin-bottom: 40px;">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Version</td>
                                                    <td><?php echo $module->getVersion(); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Preis</td>
                                                    <td><?php echo $module->getPriceFormated(); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Kompatible mit Modified</td>
                                                    <td>
                                                        <?php if ($module->getModifiedCompatibility()) { ?>
                                                            <?php foreach($module->getModifiedCompatibility() as $version) { ?>
                                                                <span class="badge badge-secondary"><?php echo $version; ?></span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            unbekannt
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Entwickler</td>
                                                    <td>
                                                        <?php if ($module->getDeveloper() && $module->getDeveloperWebsite()) { ?>
                                                            <a target="_blank" href="<?php echo $module->getDeveloperWebsite() ?>"><?php echo $module->getDeveloper() ?></a>
                                                        <?php } elseif ($module->getDeveloper()) { ?>
                                                            <?php echo $module->getDeveloper() ?>
                                                        <?php } else { ?>
                                                            unbekannter Entwickler
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="markdown">
                                        <h1>Beschreibung</h1>
                                        <p>
                                            <?php if ($module->getDescription()) { ?>
                                                <?php echo $module->getDescription() ?>
                                            <?php } else { ?>
                                                keine Beschreibung vorhanden
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-install" role="tabpanel" aria-labelledby="v-pills-install-tab">
                                    <div class="markdown">
                                        <?php if ($module->getInstallationMd()) { ?>
                                            <?php echo $module->getInstallationMd() ?>
                                        <?php } elseif ($module->getInstallation()) { ?>
                                            <?php echo $module->getInstallation() ?>
                                        <?php } else { ?>
                                            keine manuelle Installation notwendig
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-usage" role="tabpanel" aria-labelledby="v-pills-usage-tab">
                                    <div class="markdown">
                                        <?php if ($module->getUsageMd()) { ?>
                                            <?php echo $module->getUsageMd() ?>
                                        <?php } else { ?>
                                            keine Bedienungsanleitung vorhanden
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-changes" role="tabpanel" aria-labelledby="v-pills-changes-tab">
                                    <div class="markdown changelog">
                                        <?php if ($module->getChangeLogMd()) { ?>
                                            <?php echo $module->getChangeLogMd() ?>
                                        <?php } else { ?>
                                            kein Änderungsprotokoll vorhanden
                                        <?php } ?>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-details" role="tabpanel" aria-labelledby="v-pills-details-tab">
                                    <div class="infos" style="margin-bottom: 40px;">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Archivname</td>
                                                    <td><?php echo $module->getArchiveName(); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Version</td>
                                                    <td><?php echo $module->getVersion(); ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Kompatible mit Modified</td>
                                                    <td>
                                                        <?php if ($module->getModifiedCompatibility()) { ?>
                                                            <?php foreach($module->getModifiedCompatibility() as $version) { ?>
                                                                <span class="badge badge-secondary"><?php echo $version; ?></span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            unbekannt
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Entwickler</td>
                                                    <td>
                                                        <?php if ($module->getDeveloper() && $module->getDeveloperWebsite()) { ?>
                                                            <a target="_blank" href="<?php echo $module->getDeveloperWebsite() ?>"><?php echo $module->getDeveloper() ?></a>
                                                        <?php } elseif ($module->getDeveloper()) { ?>
                                                            <?php echo $module->getDeveloper() ?>
                                                        <?php } else { ?>
                                                            unbekannter Entwickler
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Alle Versionen</td>
                                                    <td>
                                                        <?php foreach($module->getVersions() as $moduleVersion) {?>
                                                            <a href="?action=moduleInfo&archiveName=<?php echo $moduleVersion->getArchiveName() ?>&version=<?php echo $moduleVersion->getVersion()?>"><?php echo $moduleVersion->getVersion(); ?></a>
                                                            <?php if ($moduleVersion->isInstalled()) { ?>
                                                                <span style="color: #bbbbbb">installiert</span>
                                                            <?php } elseif ($moduleVersion->isLoaded()) { ?>
                                                                <span style="color: #bbbbbb">geladen</span>
                                                            <?php } else { ?>
                                                                <span style="color: #bbbbbb">nicht geladen</span>
                                                            <?php } ?>
                                                            <br>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Benötigt</td>
                                                    <td>
                                                        <?php if ($module->getRequire()) { ?>
                                                            <?php foreach ($module->getRequire() as $archiveName => $version) { ?>
                                                                <a href="?action=moduleInfo&archiveName=<?php echo $archiveName?>"><?php echo $archiveName?></a><span style="color: #bbbbbb">: <?php echo $version ?></span><br>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            keine Abhängigkeit vorhanden
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Benutzt von</td>
                                                    <td>
                                                        <?php if ($module->getUsedBy()) { ?>
                                                            <?php foreach ($module->getUsedBy() as $usedBy) { ?>
                                                                <a href="?action=moduleInfo&archiveName=<?php echo $usedBy->getArchiveName()?>&version=<?php echo $usedBy->getVersion() ?>"><?php echo $usedBy->getArchiveName()?></a><span style="color: #bbbbbb">: <?php echo $usedBy->getVersion() ?></span><br>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            wird von keinem Modul verwendet
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-files" role="tabpanel" aria-labelledby="v-pills-files-tab">
                                    <h3>Geänderte Dateien</h3>

                                    <?php if ($module->isInstalled() && $module->isChanged()) { ?>
                                        <ul style="font-size: 12px">
                                            <?php foreach ($module->getChancedFiles() as $file => $mode) { ?>
                                                <li><?php echo $file ?><span style="color: #bbbbbb">: <?php echo $mode ?></span></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>
                                        keine Änderungen vorhanden
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'Footer.tmpl.php' ?>
    </body>
</html>